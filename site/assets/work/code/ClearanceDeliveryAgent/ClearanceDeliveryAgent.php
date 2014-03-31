package airport;

import airport.gui.Airport;
import airport.interfaces.*;
import airport.objects.*;

import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Set;

import agent.Agent;

/**
 * Clearance Delivery agent for airport.
 * 
 * Keeps a list of all the planes requesting a departure. Assigns a runway,
 * local controller, and ground controller. to each plane requesting departure.
 * Interacts with local controller and pilot.
 */
public class ClearanceDeliveryAgent extends Agent implements ClearanceDelivery {
    // Realworld object
    RealWorld world;
    // List of flights requesting departure
    List&ltMyFlight&gt planes;
    // List of flights requesting departure (used by GUI)
    HashMap&ltFlight, MyFlight&gt flights;
    // Name of Clearance Delivery Agent
    String name;
    // Ground Controller for current Clearance Delivery Agent
    GroundController groundcontroller;
    // Ground Controller object used for echoing purposes
    GroundController checkGC;
    // Local Controller for current Clearance Delivery Agent
    LocalController localcontroller;
    // Airport object
    Airport airport;
    // ATIS for current Clearance Delivery Agent
    ATIS aTIS;

    // Connection to GUI Panel
    private ClearanceDelivery myLinker = null;

    /**
     * Returns interface of current Clearance Delivery Agent for GUI purposes.
     * 
     * @return return Clearance Delivery interface
     */
    public ClearanceDelivery getLinker() {
        if (myLinker == null)
            myLinker = this;
        return myLinker;
    }

    /**
     * Sets Clearance Delivery, Local Controller, and Ground Controller (used by
     * GUI).
     * 
     * @param l Clearance Delivery interface
     * @param lc Local Controller interface
     * @param gc Ground Controller interface
     */
    public void setLinker(ClearanceDelivery l, LocalController lc, GroundController gc) {
        myLinker = l;
        localcontroller = lc;
        groundcontroller = gc;
    }

    // State contstants for flights
    enum MyFlightState {
        DEPARTURE_REQUESTED, 
        INFO_CHECK_REQUESTED, 
        FLIGHT_CHECK_REQUESTED, 
        RUNWAY_UPDATED, 
        NO_ACTION
    };

    /**
     * Private class storing all the information for each flight, including
     * flight, ATIS, and state.
     */
    private class MyFlight {
        MyFlightState state; // Clearance Delivery's view of the flight state
        Flight flight; // pointer to flight to retrieve its information
        Flight checkFlight; // flight for echoing purposes
        ATIS atis; // ATIS for given flight
        ATIS checkATIS; // ATIS for echoing purposes

        /**
         * Constructor for MyFlight class.
         * 
         * @param f Flight to be added to planes list
         * @param s MyFlightState to set newly added flight to
         */
        public MyFlight(Flight f, MyFlightState s) {
            flight = f;
            flights.put(f, this);
            state = s;
            atis = aTIS;
        }
    }

    /**
     * Constructor for ClearanceDeliveryAgent class.
     * 
     * @param r RealWorld object
     */
    public ClearanceDeliveryAgent(RealWorld r) {
        world = r;
        planes = Collections.synchronizedList(new ArrayList&ltMyFlight&gt());
        flights = new HashMap&ltFlight, MyFlight&gt();
    }

    /**
     * Constructor for ClearanceDeliveryAgent class.
     * 
     * @param a reference to Airport
     * @param lc local controller for clearance delivery
     * @param gc ground controller for clearance delivery
     * @param name name of clearance delivery
     * @param w ATIS for clearance delivery
     */
    public ClearanceDeliveryAgent(Airport a, LocalController lc, GroundController gc, 
                                    String name, ATIS w) {
        airport = a;
        this.name = name;
        localcontroller = (LocalControllerAgent) lc;
        groundcontroller = (GroundControllerAgent) gc;
        aTIS = w;
        planes = Collections.synchronizedList(new ArrayList&ltMyFlight&gt());
        flights = new HashMap&ltFlight, MyFlight&gt();

    }

    // *** MESSAGES ***

    /**
     * Pilot sends this to give the clearance delivery a new flight.
     * 
     * @param flight flight requesting departure
     */
    public void msgRequestTakeOff(Flight flight) {
        // create new MyFlight object using passed flight
        MyFlight myplane = new MyFlight(flight,MyFlightState.DEPARTURE_REQUESTED); 
        planes.add(myplane); // add flight to planes list
        stateChanged();
    }

    /**
     * Local Controller sends this to give the clearance delivery a flight with
     * an updated runway.
     * 
     * @param flight
     *            flight requesting departure
     */
    public void msgRunwayUpdated(Flight flight) {
        for (MyFlight myplane : planes) {
            if (myplane.flight == flight) {
                myplane.flight = flight;
                myplane.state = MyFlightState.RUNWAY_UPDATED;
            }
        }
        stateChanged();
    }

    /**
     * Pilot sends this to echo flight requesting departure.
     * 
     * @param p pilot of flight
     * @param flight flight requesting departure
     */
    public void msgEchoTakeOffID(Pilot p, Flight flight) {
        for (MyFlight myplane : planes) {
            if (myplane.flight == flight) {
                myplane.checkFlight = flight;
                myplane.state = MyFlightState.FLIGHT_CHECK_REQUESTED;
            }
        }
        stateChanged();
    }

    /**
     * Pilot sends this to echo flight information.
     * 
     * @param flight flight requesting departure
     * @param groundController ground controller for flight
     * @param aTIS ATIS for flight
     */
    public void msgEchoInfo(Flight flight, GroundController groundController, 
                                ATIS aTIS) {
        for (MyFlight myplane : planes) {
            if (myplane.flight == flight) {
                myplane.checkATIS = aTIS;
                checkGC = groundController;
                myplane.state = MyFlightState.INFO_CHECK_REQUESTED;
            }
        }
        stateChanged();
    }

    /**
     * Unused message. Needs to be implemented to use clearance delivery
     * interface.
     * 
     * @param pilot pilot
     * @param gate gate
     * @param foreignDestination foreign destination
     */
    public void msgRequestTakeOff(Pilot pilot, Location gate, String foreignDestination) {
    }

    /**
     * Unused message. Needs to be implemented to use clearance delivery
     * interface.
     * 
     * @param flight flight
     * @param groundController ground controller
     * @param aTIS ATIS
     */
    public void msgEchoInfo(Flight flight, GroundControllerAgent groundController, 
                               ATIS aTIS) {
    }

    // *** SCHEDULER ***

    /** Scheduler. Determine what action is called for, and do it. */
    protected boolean pickAndExecuteAnAction() {
        for (MyFlight myplane : planes) {
            if (myplane.state == MyFlightState.DEPARTURE_REQUESTED) {
                clearDeparture(myplane);
                return true;
            }
            if (myplane.state == MyFlightState.RUNWAY_UPDATED) {
                acceptTakeOff(myplane);
                return true;
            }
            if (myplane.state == MyFlightState.FLIGHT_CHECK_REQUESTED) {
                checkFlightID(myplane);
                return true;
            }
            if (myplane.state == MyFlightState.INFO_CHECK_REQUESTED) {
                checkInfo(myplane);
                return true;
            }

        }

        // we have tried all our rules and found nothing to do.
        // So return false to main loop of abstract agent and wait.
        return false;
    }

    // *** ACTIONS ***

    /**
     * Start clearing a flight for departure.
     * 
     * @param myplane flight requesting departure
     */
    public void clearDeparture(MyFlight myplane) {
        myplane.state = MyFlightState.NO_ACTION;
        stateChanged();
        doGetRunway(myplane.flight);
    }

    /**
     * Allow a flight to take off.
     * 
     * @param myplane flight requesting departure
     */
    public void acceptTakeOff(MyFlight myplane) {
        myplane.state = MyFlightState.NO_ACTION;
        stateChanged();
        doAcceptFlight(myplane.flight);
    }

    /**
     * Check to make sure departing flight's info is correct.
     * 
     * @param myplane flight requesting departure
     */
    public void checkInfo(MyFlight myplane) {
        print("Checking info for " + myplane.flight.toString() + ".");

        if (groundcontroller == checkGC && myplane.atis == myplane.checkATIS) {
            myplane.state = MyFlightState.NO_ACTION;
            doSendConfirm(myplane.flight);
        } else {
            myplane.state = MyFlightState.INFO_CHECK_REQUESTED;
        }
        stateChanged();
    }

    /**
     * Check to make sure departing flight's has correct runway.
     * 
     * @param myplane flight requesting departure
     */
    public void checkFlightID(MyFlight myplane) {
        print("Checking runway for " + myplane.flight.toString() + ".");
        if (myplane.flight == myplane.checkFlight) {
            myplane.state = MyFlightState.NO_ACTION;
            doSendInfo(myplane.flight);
        } else {
            myplane.state = MyFlightState.FLIGHT_CHECK_REQUESTED;
        }
        stateChanged();
    }

    /**
     * Send msgTakeOffAccepted to pilot. Called by GUI.
     * 
     */
    public void doAcceptFlight(Flight f) {
        print("Accepting take off of " + f.toString() + ".");
        f.getActivePilot().msgTakeOffAccepted(this, f);
        stateChanged();
    }

    /**
     * Send msgRequestRunway to local controller to get a runway for the flight.
     * Called by GUI.
     * 
     */
    public void doGetRunway(Flight f) {
        print("Clearing " + f.toString() + ".");
        localcontroller.msgRequestRunway(this, f);
        stateChanged();
    }

    /**
     * Send msgConfirmTakeOff to pilot. Called by GUI.
     * 
     */
    public void doSendConfirm(Flight f) {
        f.getActivePilot().msgConfirmTakeOff(this);
        stateChanged();
    }

    /**
     * Send msgInfo to pilot with ground controller and ATIS. Called by GUI.
     * 
     */
    public void doSendInfo(Flight f) {
        for (MyFlight myplane : planes) {
            if (myplane.flight == f) {
                f.getActivePilot().msgInfo(this, groundcontroller, myplane.atis);
            }
        }
        stateChanged();
    }

    /**
     * Return clearance delivery's name
     * 
     * @return return clearance delivery's name
     */
    public String getName() {
        return name;
    }

    /**
     * Set clearance delivery's name
     * 
     * @param n name of clearance delivery
     */
    public void setName(String n) {
        name = n;
    }

    /**
     * Set ground controller's name
     * 
     * @param gc name of ground controller
     */
    public void setGroundController(GroundController gc) {
        groundcontroller = gc;
    }

    /**
     * Set local controller's name
     * 
     * @param lc name of local controller
     */
    public void setLocalController(LocalController lc) {
        localcontroller = lc;
    }

    /**
     * Return flight set for GUI purposes.
     * 
     * @return return set of flights
     */
    public Set&ltFlight&gt getFlights() {
        return flights.keySet();
    }
}

/****************************************************************************************
 * 
 ****************************************************************************************/

package airport;

import junit.framework.TestCase;
import agent.*;
import airport.*;
import airport.objects.*;
import mock.*;
import static org.junit.Assert.*;
import java.util.*;

/**
 * Tests most of the functioning of the ClearanceDeliveryAgent.
 */
public class ClearanceDeliveryAgentTests extends TestCase {
    MockPilot p, p2;
    MockGroundController g, g2;
    MockLocalController l;
    Flight f, f2;
    ClearanceDeliveryAgent cd;
    RealWorld r;
    Gate gate;

    public ClearanceDeliveryAgentTests(String s) {
        super(s);
    }

    /*
     * SCENARIO 1: Normative scenario for Clearance Delivery. The Clearance
     * Delivery has no flights to take care of and then is sent a message to
     * start clearing a flight for takeoff. The expectation is that all four
     * actions: 1. clearDeparture 2. acceptTakeOff 3. checkFlightID 4. checkInfo
     * will occur after 4 sequential calls to the scheduler
     */

    /**
     * Tests: Message: setBreakStatus(true), Actions: initiateBreak, startBreak
     */

    public void test1() {
        p = new MockPilot("MockPilot");
        g = new MockGroundController("MockGroundController");
        l = new MockLocalController("MockLocalController");
        r = new RealWorld();
        cd = new ClearanceDeliveryAgent(r);
        cd.setName("Clearance Delivery Agent");
        cd.aTIS = new ATIS();
        gate = new Gate();
        gate.setName("Gate 1");
        f = new Flight(p, "destination1", gate, true, "Test Flight 1");

        // Checks that the planes list is empty
        assertTrue("cd should have no planes: ", cd.planes.size() == 0);
        // Checks that the flights list is empty
        assertTrue("cd should have no flights: ", cd.flights.size() == 0);

        // Message:
        cd.setGroundController(g);
        cd.setLocalController(l);

        // Checks that Ground Controller was properly set
        assertTrue("cd ground controller should be properly set: ",
                cd.groundcontroller == g);
        // Checks that Local Controller was properly set
        assertTrue("cd local controller should be properly set: ",
                cd.localcontroller == l);

        // Checks that the planes list has no planes
        assertTrue("cd should have no planes: ", cd.planes.size() == 0);
        // Checks that the flights list has no flights
        assertTrue("cd should have no flights: ", cd.flights.size() == 0);

        cd.msgRequestTakeOff(f);

        // call scheduler
        cd.pickAndExecuteAnAction();
        assertTrue("l should have msgRequestRunway: ", l.log
                .getLastLoggedEvent().toString().contains("msgRequestRunway"));

        // Checks that the planes list has 1 plane
        assertTrue("cd should have one plane: ", cd.planes.size() == 1);
        // Checks that the flights list has 1 flight
        assertTrue("cd should have one flight: ", cd.flights.size() == 1);

        // call scheduler
        cd.msgRunwayUpdated(f);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgTakeOffAccepted: ", p.log
                .getLastLoggedEvent().toString().contains("msgTakeOffAccepted"));

        // call scheduler
        cd.msgEchoTakeOffID(p, f);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgInfo: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgInfo"));

        // call scheduler
        cd.msgEchoInfo(f, g, cd.aTIS);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgConfirmTakeOff: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgConfirmTakeOff"));
    }

    /*
     * SCENARIO 2: Non-Normative scenario for Clearance Delivery. The Clearance
     * Delivery has no flights to take care of and then is sent a message to
     * start clearing a flight for takeoff. The Pilot echoes incorrect
     * information so Clearance Delivery resends the info to be echoed back
     * again. The expectation is that all four actions: 1. clearDeparture 2.
     * acceptTakeOff 3. checkFlightID 4. checkInfo will occur after 6 sequential
     * calls to the scheduler
     */

    /**
     * Tests: Message: setBreakStatus(true), Actions: initiateBreak, startBreak
     */

    public void test2() {
        p = new MockPilot("MockPilot");
        p2 = new MockPilot("IncorrectMockPilot");
        g = new MockGroundController("MockGroundController");
        g2 = new MockGroundController("IncorrectMockGroundController");
        l = new MockLocalController("MockLocalController");
        r = new RealWorld();
        cd = new ClearanceDeliveryAgent(r);
        cd.setName("Clearance Delivery Agent");
        cd.aTIS = new ATIS();
        gate = new Gate();
        gate.setName("Gate 1");
        f = new Flight(p, "destination", gate, true, "Test Flight 1");
        f2 = new Flight(p2, "destination2", gate, true, "Test Flight 2");

        // Checks that the planes list is empty
        assertTrue("cd should have no planes: ", cd.planes.size() == 0);
        // Checks that the flights list is empty
        assertTrue("cd should have no flights: ", cd.flights.size() == 0);

        // Message:
        cd.setGroundController(g);
        cd.setLocalController(l);

        // Checks that Ground Controller was properly set
        assertTrue("cd ground controller should be properly set: ", cd.groundcontroller == g);
        // Checks that Local Controller was properly set
        assertTrue("cd local controller should be properly set: ", cd.localcontroller == l);

        // Checks that the planes list has no planes
        assertTrue("cd should have no planes: ", cd.planes.size() == 0);
        // Checks that the flights list has no flights
        assertTrue("cd should have no flights: ", cd.flights.size() == 0);

        cd.msgRequestTakeOff(f);

        // call scheduler
        cd.pickAndExecuteAnAction();
        assertTrue("l should have msgRequestRunway: ", 
                    l.log.getLastLoggedEvent().toString().contains("msgRequestRunway"));

        // Checks that the planes list has 1 plane
        assertTrue("cd should have one plane: ", cd.planes.size() == 1);
        // Checks that the flights list has 1 flight
        assertTrue("cd should have one flight: ", cd.flights.size() == 1);

        // call scheduler
        cd.msgRunwayUpdated(f);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgTakeOffAccepted: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgTakeOffAccepted"));

        // call scheduler
        cd.msgEchoTakeOffID(p2, f2);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgTakeOffAccepted: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgTakeOffAccepted"));
        cd.msgEchoTakeOffID(p, f);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgInfo: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgInfo"));

        // call scheduler
        cd.msgEchoInfo(f2, g2, cd.aTIS);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgInfo: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgInfo"));
        cd.msgEchoInfo(f, g, cd.aTIS);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgConfirmTakeOff: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgConfirmTakeOff"));
    }

    /*
     * SCENARIO 3: Normative scenario with multiple planes for Clearance
     * Delivery. The Clearance Delivery has no flights to take care of and then
     * is sent a message to start clearing 2 flights for takeoff. The Pilot
     * echoes incorrect information so Clearance Delivery resends the info to be
     * echoed back again. The expectation is that all four actions: 1.
     * clearDeparture 2. acceptTakeOff 3. checkFlightID 4. checkInfo will occur
     * after 8 sequential calls to the scheduler
     */

    /**
     * Tests: Message: setBreakStatus(true), Actions: initiateBreak, startBreak
     */

    public void test3() {
        p = new MockPilot("MockPilot");
        p2 = new MockPilot("MockPilot2");
        g = new MockGroundController("MockGroundController");
        l = new MockLocalController("MockLocalController");
        r = new RealWorld();
        cd = new ClearanceDeliveryAgent(r);
        cd.setName("Clearance Delivery Agent");
        cd.aTIS = new ATIS();
        gate = new Gate();
        gate.setName("Gate 1");
        f = new Flight(p, "destination", gate, true, "Test Flight 1");
        f2 = new Flight(p2, "destination2", gate, true, "Test Flight 2");

        // Checks that the planes list is empty
        assertTrue("cd should have no planes: ", 
                    cd.planes.size() == 0);
        // Checks that the flights list is empty
        assertTrue("cd should have no flights: ", 
                    cd.flights.size() == 0);

        // Message:
        cd.setGroundController(g);
        cd.setLocalController(l);

        // Checks that Ground Controller was properly set
        assertTrue("cd ground controller should be properly set: ",
                cd.groundcontroller == g);
        // Checks that Local Controller was properly set
        assertTrue("cd local controller should be properly set: ",
                    cd.localcontroller == l);

        // Checks that the planes list has no planes
        assertTrue("cd should have no planes: ", 
                    cd.planes.size() == 0);
        // Checks that the flights list has no flights
        assertTrue("cd should have no flights: ", 
                    cd.flights.size() == 0);

        cd.msgRequestTakeOff(f);
        cd.msgRequestTakeOff(f2);

        // Checks that the planes list has 1 plane
        assertTrue("cd should have two planes: ", 
                    cd.planes.size() == 2);
        // Checks that the flights list has 1 flight
        assertTrue("cd should have two flights: ", 
                    cd.flights.size() == 2);

        // call scheduler
        cd.pickAndExecuteAnAction();
        assertTrue("l should have msgRequestRunway: ", 
                    l.log.getLastLoggedEvent().toString().contains("msgRequestRunway"));

        // call scheduler
        cd.pickAndExecuteAnAction();
        assertTrue("l should have msgRequestRunway: ", 
                    l.log.getLastLoggedEvent().toString().contains("msgRequestRunway"));

        // call scheduler
        cd.msgRunwayUpdated(f);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgTakeOffAccepted: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgTakeOffAccepted"));

        // call scheduler
        cd.msgRunwayUpdated(f2);
        cd.pickAndExecuteAnAction();
        assertTrue("p2 should have msgTakeOffAccepted: ", 
                    p2.log.getLastLoggedEvent().toString().contains("msgTakeOffAccepted"));

        // call scheduler
        cd.msgEchoTakeOffID(p, f);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgInfo: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgInfo"));

        // call scheduler
        cd.msgEchoTakeOffID(p2, f2);
        cd.pickAndExecuteAnAction();
        assertTrue("p2 should have msgInfo: ", 
                    p2.log.getLastLoggedEvent().toString().contains("msgInfo"));

        // call scheduler
        cd.msgEchoInfo(f, g, cd.aTIS);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgConfirmTakeOff: ", 
                    p.log.getLastLoggedEvent().toString().contains("msgConfirmTakeOff"));

        // call scheduler
        cd.msgEchoInfo(f2, g, cd.aTIS);
        cd.pickAndExecuteAnAction();
        assertTrue("p should have msgConfirmTakeOff: ", 
                    p2.log.getLastLoggedEvent().toString().contains("msgConfirmTakeOff"));
    }
}