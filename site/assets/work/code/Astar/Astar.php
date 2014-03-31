#include "stdio.h"
#include &ltstring&gt
#include &ltqueue&gt
#include &ltvector&gt
#include &ltlist&gt
#include &ltsys/time.h&gt
using namespace std;

// State class representing cells
class State
{
private:
    int x,y;
    int g;
    int h;
    int f;
    int expandedIteration;
    bool obstacle;
    bool actionNorth;
    bool actionSouth;
    bool actionWest;
    bool actionEast;
    bool inOPENList;
    bool inCLOSEDList;
    bool onPath;
    bool knownToAgent;
    State *parent;

public:
    State() {};
    ~State() {};
    int getX() {return x;};
    int getY() {return y;};
    int getG() {return g;};
    int getH() {return h;};
    int getF() {return f;};
    int getExpandedIteration() {return expandedIteration;};
    bool getObstacle() {return obstacle;};
    bool getActionNorth() {return actionNorth;};
    bool getActionSouth() {return actionSouth;};
    bool getActionWest() {return actionWest;};
    bool getActionEast() {return actionEast;};
    bool getInOPENList() {return inOPENList;};
    bool getInCLOSEDList() {return inCLOSEDList;};
    bool getOnPath() {return onPath;};
    bool getKnownToAgent() {return knownToAgent;};
    State* getParent() {return parent;};
    void setX(int i) {x=i;};
    void setY(int i) {y=i;};
    void setG(int i);
    void setH(int i);
    void setF(int i);
    void calcF();
    void setExpandedIteration(int i) {expandedIteration=i;};
    void setObstacle(bool b) {obstacle = b;};
    void setInOPENList(bool b) {inOPENList = b;};
    void setInCLOSEDList(bool b) {inCLOSEDList = b;};
    void setOnPath(bool b) {onPath = b;};
    void setKnownToAgent(bool b) {knownToAgent = b;};
    void setParent(State* s) {parent = s;};
    void checkActions();
};

// Comparison function required for priority_queue
class CompareState {
public:
    bool operator()(State* s1, State* s2) // Returns true if s1 has a greater f-value than s2
    {
        if ( s1-&gtgetF()&gts2-&gtgetF() ) 
            return true;
        // break ties with g-value
        if ( s1-&gtgetF()==s2-&gtgetF() && s1-&gtgetG()&gts2-&gtgetG() )
            return true;
        // break ties randomly with pointer address
        if ( s1-&gtgetF()==s2-&gtgetF() && s1-&gtgetG()==s2-&gtgetG() && s1&gts2) 
            return true;
        return false;
    }
};

// Astar search class
class Astar
{
private:
    float runtime;
    int currentX, currentY;
    int goalX, goalY;
    int numSearches;
    int numExpandedCells;
    float expandedCellsPerSearch;
    bool repeated;
    bool adaptive;
    bool forward;
    bool backward;
    priority_queue&ltState*, vector&ltState*&gt, CompareState&gt OPEN;
    list&ltState*&gt CLOSED;
public:
    Astar() {repeated=false;adaptive=false;forward=false;backward=false;};
    ~Astar() {};
    void setRuntime(float f) {runtime = f;};
    void setRepeated(bool b) {repeated = b;};
    void setAdaptive(bool b) {adaptive = b;};
    void setForward(bool b) {forward = b;};
    void setBackward(bool b) {backward = b;};
    bool getRepeated() {return repeated;};
    bool getAdaptive() {return adaptive;};
    bool getForward() {return forward;};
    bool getBackward() {return backward;};
    void PerformSearch();
    void ComputePath();
    void PrintPath();
    void MoveAlongPath();
    void PrintSummary();
};

// global variables
int counter;
int WIDTH;
int HEIGHT;
int agentX;
int agentY;
int targetX;
int targetY;
vector&lt vector&ltState*&gt &gt states;    // 2D vector of cell pointers
// for initialization, editing,
// and referencing
list&ltAstar&gt AstarSearches;    // list of Astar searches allowing
// performance of multiple searches

// global function declarations
void readFile(FILE *);
void printConfiguration();    // print initial gridworld configuration
void resetStates();    // reset state values in between searches

// main function
int main(int argc, char *argv[])
{ 
    FILE *f;
    f  = fopen(argv[2], "r" );
    //f  = fopen("inputfile0.txt", "r" );
    if(f==NULL) {
        printf("Error: can't open file.\n");
        return 1;
    }

    readFile(f);
    fclose(f);
    printConfiguration();

    // parse command line arguments to determine
    // whether to run repeated or adaptive A*
    bool adaptive = false; 
    if( argv[3] && string(argv[3]) =="-A" )
        adaptive = true;
    Astar astar;
    if( adaptive )
        astar.setAdaptive(true);
    else
        astar.setRepeated(true);
    astar.setForward(true);
    AstarSearches.push_back(astar);

    /*
    // all possible A* search types
    Astar repeatedForward;
    repeatedForward.setRepeated(true);
    repeatedForward.setForward(true);

    Astar repeatedBackward;
    repeatedBackward.setRepeated(true);
    repeatedBackward.setBackward(true);

    Astar adaptiveForward;
    adaptiveForward.setAdaptive(true);
    adaptiveForward.setForward(true);

    Astar adaptiveBackward;
    adaptiveBackward.setAdaptive(true);
    adaptiveBackward.setBackward(true);

    AstarSearches.push_back(repeatedForward);
    AstarSearches.push_back(repeatedBackward);
    AstarSearches.push_back(adaptiveForward);
    AstarSearches.push_back(adaptiveBackward);
    */

    // loop to perform all searches in AstarSearches
    // list, timing functionality implemented
    list&ltAstar&gt::iterator it = AstarSearches.begin();
    while( it != AstarSearches.end() ) 
    {
        struct timeval tv1, tv2;
        gettimeofday(&tv1, NULL);
        //clock_t start,end;
        //start = clock();

        (*it).PerformSearch();

        //end = clock();
        //(*it).setRuntime( ( (end-start)*1000 )/CLOCKS_PER_SEC );
        gettimeofday(&tv2, NULL);
        (*it).setRuntime( ( 1000.0*(tv2.tv_sec - tv1.tv_sec) + (tv2.tv_usec - tv1.tv_usec)/1000.0 ) + 0.5 );

        it++;
        if( it!=AstarSearches.end() )
            resetStates();
    }

    // print statistical summary for all A* searches
    if( AstarSearches.size()&gt1 )
        printf("SUMMARY OF A* SEARCHES\n");
    else
        printf("SUMMARY OF A* SEARCH\n");
    for( it = AstarSearches.begin(); it != AstarSearches.end(); it++ ) 
    {
        (*it).PrintSummary();
    }

    return 0;
}

// State functions
void State::setG(int i)
{
    if( i&lt0 )
        g=INT_MAX;
    else
        g=i;
}
void State::setH(int i)
{
    if( i&lt0 )
        h=INT_MAX;
    else
        h=i;
}
void State::setF(int i)
{
    if( i&lt0 )
        f=INT_MAX;
    else
        f=i;
}
void State::calcF()
{
    if( (g+h)&lt0 )
        f=INT_MAX;
    else
        f=g+h;
}
// check possible actions a possible from
// a given cell in the cardinal compass 
// directions; unless a state is known to
// the agent, assume it is unblocked
void State::checkActions()
{
    if( (y+1)&ltHEIGHT )
    {
        if( states[x][y+1]-&gtgetKnownToAgent() && states[x][y+1]-&gtgetObstacle() )
            actionNorth = false;
        else 
            actionNorth = true;
    }
    else
        actionNorth = false;

    if( (y-1)&gt=0 )
    {
        if( states[x][y-1]-&gtgetKnownToAgent() && states[x][y-1]-&gtgetObstacle() )
            actionSouth = false;
        else
            actionSouth = true;
    }
    else
        actionSouth = false;

    if( (x-1)&gt=0 )
    {
        if( states[x-1][y]-&gtgetKnownToAgent() && states[x-1][y]-&gtgetObstacle() )
            actionWest = false;
        else 
            actionWest = true;
    }
    else
        actionWest = false;

    if( (x+1)&ltWIDTH )
    {
        if( states[x+1][y]-&gtgetKnownToAgent() && states[x+1][y]-&gtgetObstacle() )
            actionEast = false;
        else
            actionEast = true;
    }
    else
        actionEast = false;
}

// Astar functions

// main search function
void Astar::PerformSearch()
{
    // print type of current search
    printf("\n\nPERFORMING ");
    if( getRepeated() )
        printf("REPEATED ");
    else if ( getAdaptive() )
        printf("ADAPTIVE ");
    if( getForward() )
        printf("FORWARD ");
    else if( getBackward() )
        printf("BACKWARD ");
    printf("A* SEARCH...\n");

    // initialize search iteration
    counter = 0;

    // set start and goal locations
    // for search depending on direction
    if( getForward() )
    {
        currentX = agentX;
        currentY = agentY;
        goalX = targetX;
        goalY = targetY;
    }
    else if( getBackward() )
    {
        currentX = targetX;
        currentY = targetY;
        goalX = agentX;
        goalY = agentY;
    }

    // initialize total of cells expanded
    numExpandedCells = 0;

    // main search loop until agent has reached goal
    while( !( currentX==goalX && currentY==goalY ) )
    {
        // clear the open list
        while( OPEN.size()&gt0 )
        {
            OPEN.top()-&gtsetInOPENList(false);
            OPEN.pop();
        }
        //clear the closed list
        for (list&ltState*&gt::iterator it = CLOSED.begin(); it != CLOSED.end(); it++) 
        {
            (*it)-&gtsetInCLOSEDList(false);
            // update h values if running adaptive A*
            if( getAdaptive() && counter&gt1 )
            {
                if( getForward() )
                {
                    (*it)-&gtsetH( states[goalX][goalY]-&gtgetG() - (*it)-&gtgetG() );
                    (*it)-&gtcalcF();
                }
                else if( getBackward() )
                {
                    (*it)-&gtsetH( (*it)-&gtgetG() - states[currentX][currentY]-&gtgetG() );
                    (*it)-&gtcalcF();
                }
            }
        }
        CLOSED.clear();

        counter++;      // increment search iteration

        // set g,f, and expandedIteration values for current state
        states[currentX][currentY]-&gtsetG(0);
        states[currentX][currentY]-&gtcalcF();
        states[currentX][currentY]-&gtsetExpandedIteration(counter);

        // set goal g and f to infinity
        states[goalX][goalY]-&gtsetG(INT_MAX);
        states[goalX][goalY]-&gtsetF(INT_MAX);

        // add current state to open list
        OPEN.push(states[currentX][currentY]);
        states[currentX][currentY]-&gtsetInOPENList(true);
        ComputePath();      // perform A* search

        // after computing path if open list empty
        // return failure
        if(OPEN.size()==0)
        {
            printf("\nI cannot reach the target.\n\n");
            return;
        }
        // if open list !empty move agent along path
        else
        {
            MoveAlongPath();    
        }
        // if the agent has reached the target break
        // out of search loop
        if( currentX==goalX && currentY==goalY )
            break;
    }
    // gather statistical info
    numSearches = counter;      
    expandedCellsPerSearch = ( (float)(numExpandedCells) )/numSearches;     
    printf("\nI reached the target.\n\n");      // print success

}
// A* search function
void Astar::ComputePath()
{
    // loop while open list !empty and if f-value of lowest f-value
    // state no smaller than g-value of the goal state, then search 
    // over, other perform A*
    while( OPEN.size()&gt0 && !( OPEN.top()-&gtgetInCLOSEDList() ) 
        && states[goalX][goalY]-&gtgetG() &gt OPEN.top()-&gtgetF() )
    {
        // remove state s
        State* s = OPEN.top();      
        OPEN.pop();
        // expand state s
        CLOSED.push_back(s);
        //printf("(%d,%d)\n",s-&gtgetX(),s-&gtgetY());    // print expanded states
        numExpandedCells++;
        s-&gtsetInCLOSEDList(true);
        s-&gtsetInOPENList(false);

        int x = s-&gtgetX();
        int y = s-&gtgetY();

        // set adjacent cells to agent as known
        // so that blockage status is known
        if( getForward() )
        {
            if( currentX==x && currentY==y )
            {
                if( (y+1)&ltHEIGHT )
                    states[x][y+1]-&gtsetKnownToAgent(true);
                if( (y-1)&gt=0 )
                    states[x][y-1]-&gtsetKnownToAgent(true);
                if( (x-1)&gt=0 )
                    states[x-1][y]-&gtsetKnownToAgent(true);
                if( (x+1)&ltWIDTH )
                    states[x+1][y]-&gtsetKnownToAgent(true);
            }
        }
        else if( getBackward() )
        {
            if( goalX==x && goalY==y )
            {
                if( (goalY+1)&ltHEIGHT )
                    states[goalX][goalY+1]-&gtsetKnownToAgent(true);
                if( (goalY-1)&gt=0 )
                    states[goalX][goalY-1]-&gtsetKnownToAgent(true);
                if( (goalX-1)&gt=0 )
                    states[goalX-1][goalY]-&gtsetKnownToAgent(true);
                if( (goalX+1)&ltWIDTH )
                    states[goalX+1][goalY]-&gtsetKnownToAgent(true);
            }
        }

        // determine possible actions for current state
        s-&gtcheckActions();

        // process the current state's actions
        if( s-&gtgetActionNorth() )
        {
            if( states[x][y+1]-&gtgetExpandedIteration() &lt counter )
            {
                states[x][y+1]-&gtsetG(INT_MAX);
                states[x][y+1]-&gtsetF(INT_MAX);
                states[x][y+1]-&gtsetExpandedIteration(counter);
            }
            if( states[x][y+1]-&gtgetG() &gt (s-&gtgetG()+1) )
            {
                states[x][y+1]-&gtsetG( s-&gtgetG()+1 );
                states[x][y+1]-&gtcalcF();
                states[x][y+1]-&gtsetParent(s);
                if( !( states[x][y+1]-&gtgetInOPENList() ) )
                {
                    OPEN.push( states[x][y+1] );
                    states[x][y+1]-&gtsetInOPENList(true);
                }
            }
        }

        if( s-&gtgetActionSouth() )
        {
            if( states[x][y-1]-&gtgetExpandedIteration() &lt counter )
            {
                states[x][y-1]-&gtsetG(INT_MAX);
                states[x][y-1]-&gtsetF(INT_MAX);
                states[x][y-1]-&gtsetExpandedIteration(counter);
            }
            if( states[x][y-1]-&gtgetG() &gt (s-&gtgetG()+1) )
            {
                states[x][y-1]-&gtsetG( s-&gtgetG()+1 );
                states[x][y-1]-&gtcalcF();
                states[x][y-1]-&gtsetParent(s);
                if( !( states[x][y-1]-&gtgetInOPENList() ) )
                {
                    OPEN.push( states[x][y-1] );
                    states[x][y-1]-&gtsetInOPENList(true);
                }
            }
        }

        if( s-&gtgetActionWest() )
        {
            if( states[x-1][y]-&gtgetExpandedIteration() &lt counter )
            {
                states[x-1][y]-&gtsetG(INT_MAX);
                states[x-1][y]-&gtsetF(INT_MAX);
                states[x-1][y]-&gtsetExpandedIteration(counter);
            }
            if( states[x-1][y]-&gtgetG() &gt (s-&gtgetG()+1) )
            {
                states[x-1][y]-&gtsetG( s-&gtgetG()+1 );
                states[x-1][y]-&gtcalcF();
                states[x-1][y]-&gtsetParent(s);
                if( !( states[x-1][y]-&gtgetInOPENList() ) )
                {
                    OPEN.push( states[x-1][y] );
                    states[x-1][y]-&gtsetInOPENList(true);
                }
            }
        }

        if( s-&gtgetActionEast() )
        {
            if( states[x+1][y]-&gtgetExpandedIteration() &lt counter )
            {
                states[x+1][y]-&gtsetG(INT_MAX);
                states[x+1][y]-&gtsetF(INT_MAX);
                states[x+1][y]-&gtsetExpandedIteration(counter);
            }
            if( states[x+1][y]-&gtgetG() &gt (s-&gtgetG()+1) )
            {
                states[x+1][y]-&gtsetG( s-&gtgetG()+1 );
                states[x+1][y]-&gtcalcF();
                states[x+1][y]-&gtsetParent(s);
                if( !( states[x+1][y]-&gtgetInOPENList() ) )
                {
                    OPEN.push( states[x+1][y] );
                    states[x+1][y]-&gtsetInOPENList(true);
                }
            }
        }
    }
}
// prints path from latest A* search
void Astar::PrintPath()
{
    for(int y=HEIGHT-1;y&gt=0;y--)
    {
        if(y==HEIGHT-1)
        {
            if(HEIGHT&gt100)
                printf("  ");
            if(HEIGHT&gt10)
                printf(" ");
            printf(" ");
            for(int i=0;i&ltWIDTH;i++)
            {
                printf("%d",i);
            }
            printf("\n");
        }
        printf("%d",y);
        for(int x=0;x&ltWIDTH;x++)
        {
            if(x==0)
            {
                if( WIDTH&gt100 && y&lt100)
                    printf("  ");
                if( WIDTH&gt10 && y&lt10 )
                    printf(" ");
            }
            if( x == goalX && y == goalY )
            {
                if( getForward() )
                    printf("T");
                else if( getBackward() )
                    printf("A");
            }
            else if( x == currentX && y == currentY )
            {
                if( getForward() )
                    printf("A");
                else if( getBackward() )
                    printf("T");
            }
            else if( states[x][y]-&gtgetKnownToAgent() )
            {
                if( states[x][y]-&gtgetObstacle() )
                    printf("X");
                else if( states[x][y]-&gtgetOnPath() )
                {
                    printf(".");
                    states[x][y]-&gtsetOnPath(false);
                }
                else
                    printf(" ");
            }
            else if( states[x][y]-&gtgetOnPath() )
            {
                printf(".");
                states[x][y]-&gtsetOnPath(false);
            }
            else
                printf(" ");
        }
        printf("\n");
    }
}
// move agent along current path
void Astar::MoveAlongPath()
{
    printf("\nThe grid known to the agent with the shortest path after search [%d] is\n", counter);
    // follow tree pointers from goal to start state
    // to determine shortest path
    State* s = states[goalX][goalY]-&gtgetParent();
    while(s-&gtgetParent()!=states[currentX][currentY])
    {
        s-&gtsetOnPath(true);
        s = s-&gtgetParent();
    }
    s-&gtsetOnPath(true);
    // print current path
    PrintPath();

    // move agent along bath until reach target or
    // hit obstacle 
    while( !( currentX==goalX && currentY==goalY ) )
    {
        s = states[goalX][goalY];
        if( getForward() )
        {
            while(s-&gtgetParent()!=states[currentX][currentY])
            {
                s = s-&gtgetParent();
            }
            if( !( s-&gtgetObstacle() ) )
            {
                currentX = s-&gtgetX();
                currentY = s-&gtgetY();
                s-&gtsetOnPath(false);
                states[currentX][currentY]-&gtcheckActions();
            }
        }
        else if( getBackward() )
        {
            s = s-&gtgetParent();
            if( !( s-&gtgetObstacle() ) )
            {
                goalX = s-&gtgetX();
                goalY = s-&gtgetY();
                s-&gtsetOnPath(false);
                states[goalX][goalY]-&gtcheckActions();
            }
        }
        // if parent state to agent location not obstacle,
        // set adjacent cells to parent state as known
        if( !( s-&gtgetObstacle() ) )
        {
            if( (s-&gtgetY()+1)&ltHEIGHT )
                states[s-&gtgetX()][s-&gtgetY()+1]-&gtsetKnownToAgent(true);
            if( (s-&gtgetY()-1)&gt=0 )
                states[s-&gtgetX()][s-&gtgetY()-1]-&gtsetKnownToAgent(true);
            if( (s-&gtgetX()-1)&gt=0 )
                states[s-&gtgetX()-1][s-&gtgetY()]-&gtsetKnownToAgent(true);
            if( (s-&gtgetX()+1)&ltWIDTH )
                states[s-&gtgetX()+1][s-&gtgetY()]-&gtsetKnownToAgent(true);
        }
        if( s-&gtgetObstacle() )
        {
            states[s-&gtgetX()][s-&gtgetY()]-&gtsetKnownToAgent(true);
            break;
        }
    }
}
// print statistical summary of A* search
void Astar::PrintSummary()
{
    if( getRepeated() )
        printf("\nREPEATED ");
    else if ( getAdaptive() )
        printf("\nADAPTIVE ");
    if( getForward() )
        printf("FORWARD ");
    else if( getBackward() )
        printf("BACKWARD ");
    printf("A* SEARCH SUMMARY\n");
    printf("Number of paths computed: %d\n",numSearches);
    printf("Total states expanded: %d\n",numExpandedCells);
    printf("Cell expansion per search: %.2f\n",expandedCellsPerSearch);
    printf("Total runtime: %.0fms\n",runtime);
}

// global functions

// parse inputfiles for gridworld configuration
void readFile(FILE *f)
{
    fscanf (f, "%*s %*c %d", &WIDTH);
    fscanf (f, "%*s %*c %d", &HEIGHT);
    vector&lt vector&ltState*&gt &gt temp(WIDTH, vector&ltState*&gt(HEIGHT,static_cast&ltState*&gt(0))); 
    states = temp;

    fscanf (f, "%*s %*c %d%*c%d", &agentX, &agentY);
    fscanf (f, "%*s %*c %d%*c%d", &targetX, &targetY);

    fscanf(f, "%*s%*c");

    for(int y = HEIGHT-1; y&gt=0; y--)
    {
        for(int x = 0; x&ltWIDTH; x++)
        {
            State* s = new State();
            int b;
            s-&gtsetX(x);
            s-&gtsetY(y);
            fscanf(f, "%1d", &b);
            if(b)
                s-&gtsetObstacle(true);
            else
                s-&gtsetObstacle(false);
            s-&gtsetParent(NULL);
            s-&gtsetExpandedIteration(0);
            s-&gtsetKnownToAgent(false);
            s-&gtsetOnPath(false);
            s-&gtsetInOPENList(false);
            s-&gtsetInCLOSEDList(false);
            s-&gtsetH( abs(targetX-x) + abs(targetY-y) );
            s-&gtcalcF();
            states[x][y] = s;
        }
        fgetc(f);   
    }
}
// print initial gridworld configuration
void printConfiguration()
{
    printf("\n");
    printf("WIDTH = %d\n",WIDTH);
    printf("HEIGHT = %d\n",HEIGHT);
    printf("agent = %d,%d\n",agentX,agentY);
    printf("target = %d,%d\n",targetX,targetY);

    printf("\nThe initial grid configuration is\n");
    for(int y=HEIGHT-1;y&gt=0;y--)
    {
        if(y==HEIGHT-1)
        {
            if(HEIGHT&gt100)
                printf("  ");
            if(HEIGHT&gt10)
                printf(" ");
            printf(" ");
            for(int i=0;i&ltWIDTH;i++)
            {
                printf("%d",i);
            }
            printf("\n");
        }
        printf("%d",y);

        for(int x=0;x&ltWIDTH;x++)
        {
            if(x==0)
            {
                if( WIDTH&gt100 && y&lt100)
                    printf("  ");
                if( WIDTH&gt10 && y&lt10 )
                    printf(" ");
            }
            if(x == targetX && y == targetY )
                printf("T");
            else if(x == agentX && y == agentY )
                printf("A");
            else if( states[x][y]-&gtgetObstacle() )
                printf("X");
            else
                printf(" ");
        }
        printf("\n");
    }
}
// reset states
void resetStates()
{
    printf("\nResetting states...\n"); 
    for(int y=HEIGHT-1;y&gt=0;y--)
    {
        for(int x=0;x&ltWIDTH;x++)
        {
            State* s = states[x][y];
            s-&gtsetParent(NULL);
            s-&gtsetExpandedIteration(0);
            s-&gtsetKnownToAgent(false);
            s-&gtsetOnPath(false);
            s-&gtsetInOPENList(false);
            s-&gtsetInCLOSEDList(false);
        }
    } 
}